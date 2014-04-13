#! /usr/bin/python

# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="jon"
__date__ ="$Apr 12, 2014 11:38:00 PM$"

import urllib2
import cookielib
import poster

upload_url = "http://aqi.local/image"
files_to_process_path = "metadata"
files_processed_path = "uploaded"

if __name__ == "__main__":
  
    
  
    print "Starting upload process";
    opener = poster.streaminghttp.register_openers()
    opener.add_handler(urllib2.HTTPCookieProcessor(cookielib.CookieJar())) # Add cookie handler
    params = {'file': open("test.txt", "rb"), 'name': 'upload test'}
    datagen, headers = poster.encode.multipart_encode(params)
    request = urllib2.Request(upload_url, datagen, headers)
    result = urllib2.urlopen(request)
