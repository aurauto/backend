import django_filters
from parceServer.models import CarAd


class CarAdFilter(django_filters.FilterSet):
    aggregator = django_filters.CharFilter(lookup_expr='exact')
    brand = django_filters.CharFilter(lookup_expr='exact')
    price_min = django_filters.NumberFilter(field_name='price', lookup_expr='gte')
    price_max = django_filters.NumberFilter(field_name='price', lookup_expr='lte')
    model = django_filters.CharFilter(lookup_expr='exact')
    production_date_min = django_filters.NumberFilter(field_name='production_date', lookup_expr='gte')
    production_date_max = django_filters.NumberFilter(field_name='production_date', lookup_expr='lte')
    mileage_min = django_filters.NumberFilter(field_name='mileage', lookup_expr='gte')
    mileage_max = django_filters.NumberFilter(field_name='mileage', lookup_expr='lte')
    cars_engine = django_filters.CharFilter(lookup_expr='exact')
    engine_capacity_min = django_filters.NumberFilter(field_name='engine_capacity', lookup_expr='gte')
    engine_capacity_max = django_filters.NumberFilter(field_name='engine_capacity', lookup_expr='lte')
    cars_gearbox = django_filters.CharFilter(lookup_expr='exact')
    cars_type = django_filters.CharFilter(lookup_expr='exact')
    cars_drive = django_filters.CharFilter(lookup_expr='exact')
    condition = django_filters.CharFilter(lookup_expr='exact')
    country = django_filters.CharFilter(lookup_expr='exact')
    region = django_filters.CharFilter(lookup_expr='exact')
    area = django_filters.CharFilter(lookup_expr='exact')
    color = django_filters.CharFilter(lookup_expr='exact')
    create_date_min = django_filters.DateFilter(field_name='create_date', lookup_expr='gte')
    create_date_max = django_filters.DateFilter(field_name='create_date', lookup_expr='lte')

    class Meta:
        model = CarAd
        fields = ['aggregator', 'brand', 'price_min', 'price_max', 'model',
                  'production_date_min', 'production_date_max', 'mileage_min', 'mileage_max',
                  'cars_engine', 'engine_capacity_min', 'engine_capacity_max', 'cars_gearbox',
                  'cars_type', 'cars_drive', 'condition', 'country', 'region', 'area',
                  'color', 'create_date_min', 'create_date_max']
