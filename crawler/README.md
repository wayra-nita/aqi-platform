Installation of dependencies
------------------------------
sudo easy_install flickrapi
sudo pip install pygeocoder
sudo pip install python-slugify
sudo pip install poster


usage:

first navigate to src folder and be sure to use python 2.7+

to import the data to temporal json

$python base.yml

to upload to the webservice via post run

$python uploader.py