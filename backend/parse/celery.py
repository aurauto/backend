import os
from celery.app.base import Celery as CeleryClass
from celery.schedules import crontab
from celery import Celery
from .LIST_AM import list_am_main_cycle
from .LALAFO import lalafo_main_cycle
from .KUFAR import kufar_main_cycle
from .KOLESA_KZ import kolesa_kz_main_cycle
from django.utils import timezone

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'main.settings')

app = Celery('PARSING')
# app.conf.timezone = 'UTC'
app.conf.timezone = 'Europe/Moscow'
app.config_from_object('django.conf:settings', namespace='CELERY')
app.autodiscover_tasks()


@app.task()
def clear_old_ads():
    from parse.models import CarAd
    ads_to_delete = CarAd.objects.filter(
        edit_date__lte=timezone.now() - timezone.timedelta(days=1)
    )
    ads_to_delete.delete()


@app.task()
def list_am():
    list_am_main_cycle()
    return 'DONE'


@app.task()
def lalafo():
    lalafo_main_cycle()
    return 'DONE'


@app.task()
def kufar():
    kufar_main_cycle()
    return 'DONE'


@app.task()
def kolesa_kz():
    from datetime import datetime
    start = datetime.now()
    kolesa_kz_main_cycle()
    finish = datetime.now()
    f = open('timing.txt', 'w')
    f.write(f'start time: {start}\nfinish time: {finish}\nworking time: {str(finish - start)}')
    return 'DONE'


@app.on_after_configure.connect
def setup_periodic_tasks(sender: CeleryClass, **kwargs):
    clear_old_ads.delay()
    list_am.delay()
    # kufar.delay()
    # lalafo.delay()
    # kolesa_kz.delay()

    sender.add_periodic_task(
        crontab(minute=1, hour='*/12'),
        list_am.s(),
        start_time=timezone.datetime.now(),
        name='LIST.AM',
    )
    # sender.add_periodic_task(
    #     crontab(minute=1, hour='*/12'),
    #     kolesa_kz.s(),
    #     start_time=timezone.now(),
    #     name='KOLESA.KZ',
    # )
    # sender.add_periodic_task(
    #     crontab(minute=1, hour='*/24'),
    #     clear_old_ads.s(),
    #     start_time=timezone.now(),
    #     name='Clear old ads',
    # )
    # sender.add_periodic_task(
    #     crontab(minute=20, hour='*/12'),
    #     lalafo.s(),
    #     start_time=timezone.datetime.now(),
    #     name='LALAFO',
    #
    # )
    # sender.add_periodic_task(
    #     crontab(minute=40, hour='*/12'),
    #     kufar.s(),
    #     start_time=timezone.datetime.now(),
    #     name='KUFAR',
    # )
