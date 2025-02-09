from django_filters.rest_framework import DjangoFilterBackend
from parse.models import (
    CarAd, Brand, CarModel, Area, Region, Country, Engine, Gearbox, CarType, CarDrive, CarCondition, Color
)
from parse.tools.currency_tools import get_currency_usd_base
from rest_framework import filters
from rest_framework.decorators import api_view
from rest_framework.generics import ListAPIView, RetrieveAPIView
from rest_framework.response import Response

from .filters import *
from .paginators import CarAdPagination
from .serializers import *


class CarAdFilteredList(ListAPIView):
    def get_queryset(self):
        queryset = CarAd.objects.all()
        queryset = queryset.exclude(price__isnull=True)
        queryset = queryset.exclude(production_date__isnull=True)
        queryset = queryset.exclude(mileage__isnull=True)
        return queryset

    serializer_class = CarAdFilterSerializer
    queryset = CarAd.objects.all()
    filter_backends = [DjangoFilterBackend, filters.OrderingFilter, filters.SearchFilter]
    filterset_class = CarAdFilter
    ordering_fields = ['price', 'production_date', 'mileage', 'create_date']
    ordering = ['-create_date']
    search_fields = ['title', 'description']
    pagination_class = CarAdPagination


class CarAdDetailView(RetrieveAPIView):
    serializer_class = CarAdSerializer
    queryset = CarAd.objects.all()
    lookup_field = 'ad_id'


class BrandList(ListAPIView):
    queryset = Brand.objects.all()
    serializer_class = BrandSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter]
    search_fields = ['name']


# class AllModelsByBrand(ListAPIView):
#     serializer_class = BrandSerializer
#
#     def get_queryset(self):
#         return Brand.objects.prefetch_related('carmodel_set').all()
#

class ModelsByBrand(ListAPIView):
    serializer_class = CarModelSerializer

    def get_queryset(self):
        brand_name = self.kwargs['brand']
        return CarModel.objects.filter(brand__name=brand_name)


class AreaList(ListAPIView):
    queryset = Area.objects.all()
    serializer_class = AreaSerializer
    filterset_class = AreaFilter
    filter_backends = [DjangoFilterBackend, filters.SearchFilter]
    search_fields = ['name']


class AreaDetail(RetrieveAPIView):
    queryset = Area.objects.all()
    serializer_class = AreaSerializer
    lookup_field = 'name'


class RegionList(ListAPIView):
    queryset = Region.objects.all()
    serializer_class = RegionSerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter]
    search_fields = ['name']


class RegionDetail(RetrieveAPIView):
    queryset = Region.objects.all()
    serializer_class = RegionSerializer
    lookup_field = 'name'

    def retrieve(self, request, *args, **kwargs):
        instance = self.get_object()
        serializer = self.get_serializer(instance)
        areas_serializer = AreaSerializer(instance.area_set.all(), many=True)
        data = serializer.data
        data['areas'] = areas_serializer.data
        return Response(data)


class CountryList(ListAPIView):
    queryset = Country.objects.all()
    serializer_class = CountrySerializer
    filter_backends = [DjangoFilterBackend, filters.SearchFilter]
    search_fields = ['name']


class CountryDetail(RetrieveAPIView):
    queryset = Country.objects.all()
    serializer_class = CountrySerializer
    lookup_field = 'name'

    def retrieve(self, request, *args, **kwargs):
        country = self.get_object()
        serializer_context = self.get_serializer_context()
        regions = RegionSerializer(country.region_set.all(), many=True, context=serializer_context).data
        area_serializer = AreaListSerializer(country.area_set.filter(region__isnull=True), many=True,
                                             context=serializer_context)
        areas_without_region = area_serializer.data
        serializer = self.get_serializer(country)
        data = serializer.data
        data['regions'] = regions
        data['areas_without_region'] = areas_without_region
        return Response(data)


@api_view(['GET'])
def get_field_lists(request, item):
    field_list = {
        'cars_engine': [Engine, EngineSerializer],
        'cars_gearbox': [Gearbox, GearboxSerializer],
        'cars_type': [CarType, CarTypeSerializer],
        'cars_drive': [CarDrive, CarDriveSerializer],
        'condition': [CarCondition, CarConditionSerializer],
        'color': [Color, ColorSerializer],
    }
    current_item = field_list.get(item)
    if not current_item:
        return Response(status=404)
    model, serializer = current_item
    queryset = model.objects.all()
    return Response(
        [serializer(obj).data for obj in queryset],
        status=200,
    )


@api_view(['GET'])
def get_currency_list(request):
    return Response(
        get_currency_usd_base(),
        status=200,
    )
