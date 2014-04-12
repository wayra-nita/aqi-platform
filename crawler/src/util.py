# To change this license header, choose License Headers in Project Properties.
# To change this template file, choose Tools | Templates
# and open the template in the editor.

__author__="jon"
__date__ ="$Apr 12, 2014 1:42:34 PM$"

from urllib.request import urlopen, Request
from urllib.error import HTTPError, URLError
from urllib.parse import urlencode

def urlread(addr, urlvars, headers):
    data = None
    try: req = urlopen(Request("{0}/?{1}".format(addr, urlencode(urlvars)), None, headers))
    except HTTPError as e: print('HTTP Error: {0}. Request: {1}'.format(e.code, "{0}/?{1}".format(addr, urlencode(urlvars))))
    except URLError as e: print('URL Error: {0}'.format(e.reason))
    else:
        data = req.read().decode(req.headers.get_content_charset())
    return data
