#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="jon"
__date__ ="$Apr 12, 2014 11:38:00 PM$"

import urllib2
import cookielib
import poster
import glob
import os
import json
from pprint import pprint

upload_url = "http://aqi.local/image"
files_to_process_path = "metadata"
files_processed_path = "uploaded"

def listdirs(folder):
    return [d for d in os.listdir(folder) if os.path.isdir(os.path.join(folder, d))]

if __name__ == "__main__":
    print "starting upload process"
    for dir in listdirs(files_to_process_path):
      for file in os.listdir(files_to_process_path + "/" + dir):
        if file.endswith(".json"):
          with open(files_to_process_path + "/" + dir + "/"+file) as json_file:
            json_data = json.load(json_file)
            print(str(json_data["id"]))
            exit(0)
            opener = poster.streaminghttp.register_openers()
            opener.add_handler(urllib2.HTTPCookieProcessor(cookielib.CookieJar())) # Add cookie handler
            params = {
              'id': str(json_data["id"]), 
              'title': str(json_data["title"]), 
              'lat': str(json_data["lat"]), 
              'long': str(json_data["long"]), 
              'imgloc': str(json_data["imgloc"])}
            datagen, headers = poster.encode.multipart_encode(params)
            request = urllib2.Request(upload_url, datagen, headers)
            result = urllib2.urlopen(request)
            print result
            exit(0)
