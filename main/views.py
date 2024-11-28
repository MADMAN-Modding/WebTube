from django.template import loader
from django.http import HttpResponse
from django.shortcuts import render

# Create your views here.
def main(request):
    return HttpResponse(loader.get_template('index.html').render(request=request))