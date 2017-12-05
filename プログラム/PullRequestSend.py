# -*- coding: utf-8 -*-
#!/usr/bin/env python

import urllib
import urllib2
import sys
import requests
import os, json, functools

argvs = sys.argv
argc = len(argvs)

Owner = sys.argv[1]
RepoName = sys.argv[2]
title = unicode(argvs[3], 'cp932')
head = sys.argv[4]
base = sys.argv[5]
body = unicode(argvs[6], 'cp932')
User = sys.argv[7]
token = sys.argv[8]

head = head.encode('utf-8')
base = base.encode('utf-8')
title = title.encode('utf-8')
body = body.encode('utf-8')

payload = {
          "title": title,
          "body": body,
          "head": head,
          "base": base
       }

url='https://api.github.com/repos/%s/%s/pulls' % (Owner, RepoName)
# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
response = requests.post(url,auth=(User, token), json=payload)