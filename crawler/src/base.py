#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="jon"
__date__ ="$Apr 12, 2014 12:57:32 PM$"

import flickrapi
import json
import urllib
import os.path
from pprint import pprint


api_key = "da3cea7cccd3240398c6af0630474dd7"
flickr = flickrapi.FlickrAPI(api_key, cache=True)

for index in range(1,10):
  photos = flickr.photos_search(tags='cielo, sky', has_geo=1, page=index, per_page= 100, lat='-17.38414', lon='-66.16670199', radius='20')  
  for photo in photos[0]:
    
    if os.path.isfile('photos/'+photo.attrib['id']+'.jpg'):
      continue
      
    print("downloading file "+photo.attrib['id'])
    
    photo_location = flickr.photos_geo_getLocation(photo_id=photo.attrib['id'])
    photo_size = flickr.photos_getSizes(photo_id=photo.attrib['id'])

    data_json = {
      "id": photo.attrib['id'],  
      "title": photo.attrib['title'],  
      "lat": photo_location[0][0].attrib['latitude'], 
      "long": photo_location[0][0].attrib['longitude'],
      "imgloc": photo_size[0][6].attrib['source']
    }
    #save image file
    with open("metadata/"+photo.attrib['id']+'.json', 'w') as outfile:
      json.dump(data_json, outfile)

    #download image
    urllib.urlretrieve(photo_size[0][6].attrib['source'], 'photos/'+photo.attrib['id']+'.jpg')