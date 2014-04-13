#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="jon"
__date__ ="$Apr 12, 2014 12:57:32 PM$"

from symbol import except_clause
import flickrapi
import json
import urllib
import os.path
from pprint import pprint
from pygeocoder import Geocoder
from slugify import slugify
import os, errno


def mkdir_p(path):
    try:
        os.makedirs(path)
    except OSError as exc: # Python >2.5
        if exc.errno == errno.EEXIST and os.path.isdir(path):
            pass
        else: raise

api_key = "da3cea7cccd3240398c6af0630474dd7"
flickr = flickrapi.FlickrAPI(api_key, cache=True)

cities = ["Cochabamba, Bolivia", "Santa Cruz, Bolivia", "La Paz, Bolivia", "Des Moines,United States","Nipomo,United States","Las Vegas,United States","Paso Robles,United States","Atascadero,United States","San Luis Obispo,United States","Carrizo Plains,United States","Morro Bay,United States","Red Hills,United States","El Paso,United States","Springfield,United States","Laredo,United States","Austin,United States","Beaumont-Port Arthur,United States","Houston-Galveston-Brazoria,United States","Oxnard,United States","Waco-Killeen,United States","Phoenix,United States","Tyler-Longview-Marshall,United States","Columbus,United States","Brownsville-McAllen,United States","Dallas-Fort Worth,United States","San Antonio,United States","Youngstown,United States","Simi Valley,United States","Lake Elsinore,United States","Louisville,United States","Central LA CO,United States","Grand Junction,United States","Norco/Corona,United States"]

for city in cities:
  results = Geocoder.geocode(city)
  r_lat = str(results[0].coordinates[0])
  r_long = str(results[0].coordinates[1])
  name_city = slugify(str(results[0]))
  print  "retrieving data for city " + name_city + " lat " + r_lat + " long " + r_long 
  base_meta_dir = "metadata/"+name_city+"/"
  base_img_dir = "photos/"+name_city+"/"
  mkdir_p(base_meta_dir)
  mkdir_p(base_img_dir)
  
  for index in range(1,10):
    photos = flickr.photos_search(tags='cielo, sky, paisaje, landscape', has_geo=1, page=index, per_page= 100, lat=r_lat, lon=r_long, radius='20')  
    for photo in photos[0]:

      if os.path.isfile(base_img_dir+photo.attrib['id']+'.jpg'):
        continue

      print("downloading file "+photo.attrib['id'] + " to dir " + name_city)

      photo_location = flickr.photos_geo_getLocation(photo_id=photo.attrib['id'])
      photo_size = flickr.photos_getSizes(photo_id=photo.attrib['id'])

      imgloc = ""
      
      for indx in range(6, 1, -1):
        #download image
        try:
            imgloc = photo_size[0][indx].attrib['source']
            break
        except:
          continue
      
      data_json = {
        "id": photo.attrib['id'],  
        "title": photo.attrib['title'],  
        "lat": photo_location[0][0].attrib['latitude'], 
        "long": photo_location[0][0].attrib['longitude'],
        "imgloc": imgloc
      }
      #save image file
      with open(base_meta_dir+photo.attrib['id']+'.json', 'w') as outfile:
        json.dump(data_json, outfile)
        
      urllib.urlretrieve(imgloc, base_img_dir+photo.attrib['id']+'.jpg')
        
#  exit(0)
