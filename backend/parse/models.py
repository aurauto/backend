import copy

from django.db import models
from django.utils import timezone
from parse.tools.currency_tools import get_currency_data

from .models_exceptions import AdSetUpError


class Aggregator(models.Model):
    name = models.CharField(primary_key=True, max_length=30)

    def __str__(self):
        return self.name


class Brand(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class CarModel(models.Model):
    name = models.CharField(primary_key=True, max_length=50)
    brand = models.ForeignKey(to=Brand, on_delete=models.CASCADE)

    def __str__(self):
        return self.name


class Engine(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class Gearbox(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class CarType(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class CarDrive(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class CarCondition(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class Country(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class Region(models.Model):
    name = models.CharField(primary_key=True, max_length=50)
    country = models.ForeignKey(to=Country, on_delete=models.CASCADE)

    def __str__(self):
        return self.name


class Area(models.Model):
    name = models.CharField(primary_key=True, max_length=50)
    country = models.ForeignKey(to=Country, on_delete=models.CASCADE)
    region = models.ForeignKey(to=Region, on_delete=models.CASCADE, blank=True, null=True)

    def __str__(self):
        return self.name


class Color(models.Model):
    name = models.CharField(primary_key=True, max_length=50)

    def __str__(self):
        return self.name


class CarAd(models.Model):
    __attrs = ('ad_id', 'link', 'aggregator', 'brand', 'price', 'model', 'production_date',
               'mileage', 'cars_engine', 'engine_capacity',
               'cars_gearbox', 'cars_type', 'cars_drive', 'condition', 'country', 'region'
                                                                                  'area', 'title', 'color',
               'description', 'images')
    __fk_attrs = {'aggregator': Aggregator, 'brand': Brand, 'cars_engine': Engine,
                  'cars_gearbox': Gearbox, 'cars_type': CarType, 'cars_drive': CarDrive,
                  'condition': CarCondition, 'country': Country, 'color': Color}
    __special_fk_attrs = {'model': CarModel, 'region': Region, 'area': Area}
    __special_non_fk_attrs = {'price', }
    __optional_attributes = {'region', 'area', 'color', 'description', 'condition', 'engine_capacity', 'cars_drive',
                             'cars_type',
                             'cars_gearbox', 'mileage'}
    __required_attrs = {'link', 'aggregator', 'price', 'production_date', 'cars_engine', 'condition', 'country',
                        'title', 'images'}
    __other_attrs = (
        'link',  # str
        'production_date',  # int
        'mileage',  # int
        'engine_capacity',  # float
        'title',  # str
        'description',  # str
        'images',  # json
    )
    ad_id = models.IntegerField(unique=True)
    link = models.CharField(max_length=150)
    aggregator = models.ForeignKey(to=Aggregator, on_delete=models.CASCADE)
    brand = models.ForeignKey(to=Brand, on_delete=models.CASCADE)
    price = models.IntegerField()
    model = models.ForeignKey(to=CarModel, on_delete=models.CASCADE)
    production_date = models.IntegerField()
    mileage = models.IntegerField(blank=True, null=True)
    cars_engine = models.ForeignKey(to=Engine, on_delete=models.CASCADE)
    engine_capacity = models.FloatField(blank=True, null=True)
    cars_gearbox = models.ForeignKey(to=Gearbox, on_delete=models.CASCADE, blank=True, null=True)
    cars_type = models.ForeignKey(to=CarType, on_delete=models.CASCADE, blank=True, null=True)
    cars_drive = models.ForeignKey(to=CarDrive, on_delete=models.CASCADE, blank=True, null=True)
    condition = models.ForeignKey(to=CarCondition, on_delete=models.CASCADE, blank=True, null=True)
    country = models.ForeignKey(to=Country, on_delete=models.CASCADE)
    region = models.ForeignKey(to=Region, on_delete=models.CASCADE, null=True, blank=True)
    area = models.ForeignKey(to=Area, on_delete=models.CASCADE, blank=True, null=True)
    title = models.TextField(max_length=400)
    color = models.ForeignKey(to=Color, on_delete=models.CASCADE, blank=True, null=True)
    description = models.TextField(max_length=1000, blank=True, null=True)
    images = models.JSONField(default=dict)
    edit_date = models.DateTimeField(auto_now=True)
    create_date = models.DateTimeField(auto_now_add=True)
    price_history = models.JSONField(default=dict)

    @classmethod
    def _validate_fields(cls, ad_data: dict):
        attrs_set = {key for key, value in ad_data.items()}
        if attrs_set.intersection(cls.__required_attrs) == cls.__required_attrs:
            return ad_data['price'].get('amount') and ad_data['price'].get('currency')

    def update_object(self, **kwargs):
        for k, v in kwargs.items():
            setattr(self, k, v)
        self.save()

    # def __setup_non_fk_fields(self, field, *ags):
    #     match field:
    #         case 'price':
    #             self.__setup_price(*ags)

    def __setup_price(self, price_data: dict):
        currency_data = get_currency_data()
        currency = price_data.get('currency')
        # print(f'saving {self.ad_id}', currency)
        amount = price_data.get('amount')
        if not currency or not amount:
            raise AdSetUpError('Not enough price data ')
        price_usd = int(round(currency_data.get(currency) * amount, 1))
        self.price = price_usd
        price_dict = copy.copy(self.price_history)
        price_dict[timezone.datetime.now().strftime("%Y-%m-%dT%H:%M:%S.%f%z")] = price_usd
        self.price_history = price_dict


    def __setup_fk_attr(self, field, arg):
        if not arg and field not in self.__optional_attributes:
            raise AdSetUpError(f'Field {field} not set')
        if arg is None:
            return None
        field_class = self.__fk_attrs[field]
        field_model = field_class.objects.filter(name=arg)
        if not field_model:
            field_model = field_class.objects.create(name=arg)
        else:
            field_model = field_model[0]
        setattr(self, field + '_id', field_model)

    def __setup__special_kf_attrs(self, field, arg):
        match field:
            case 'model':
                self.__setup_car_model(arg)
            case 'region':
                self.__setup_region(arg)
            case 'area':
                self.__setup_area(arg)

    def __setup_other_attrs(self, **attrs):
        for k, v in attrs.items():
            setattr(self, k, v)

    def __setup_car_model(self, model_name: str):
        if not model_name:
            model_name = 'Другая'
        model = CarModel.objects.filter(name=model_name)
        if not model:
            model = CarModel.objects.create(name=model_name, brand=self.brand)
        else:
            model = model[0]
        self.model = model

    def __setup_region(self, region_name):
        if not region_name:
            return None
        region_model = Region.objects.filter(name=region_name)
        if not region_model:
            region_model = Region.objects.create(name=region_name, country=self.country)
        else:
            region_model = region_model[0]
        self.region = region_model
        return region_model

    def __setup_area(self, area_name):
        if not area_name:
            return None
        area_model = Area.objects.filter(name=area_name)
        if not area_model:
            area_model = Area.objects.create(name=area_name, country=self.country, region=self.region)
        else:
            area_model = area_model[0]
        self.area = area_model
        return area_model

    @classmethod
    def save_ad(cls, ad_data: dict):
        if not cls._validate_fields(ad_data):
            # print(f'ad not valid {ad_data.get("link")}')
            return None
        db_ad = CarAd.objects.filter(ad_id=ad_data['ad_id'])

        if not db_ad:
            db_ad = CarAd(ad_id=ad_data['ad_id'])
            db_ad._save_ad(ad_data)
        else:
            db_ad = db_ad[0]
            db_ad.__setup_price(ad_data.get('price'))
            db_ad.save()

    def _save_ad(self, ad_data):
        fk_fields = {key: ad_data.get(key) for key, value in self.__fk_attrs.items()}
        special_fk_fields = {key: ad_data.get(key) for key, value in self.__special_fk_attrs.items()}
        other_fields = {key: ad_data.get(key) for key in self.__other_attrs}
        for field, arg in fk_fields.items():
            self.__setup_fk_attr(field, arg)
        self.__setup_price(ad_data.get('price'))
        for field, arg in special_fk_fields.items():
            self.__setup__special_kf_attrs(field, arg)
        self.__setup_other_attrs(**other_fields)
        self.save()


