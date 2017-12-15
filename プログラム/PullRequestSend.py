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

Owner = Owner[1:]
Owner = Owner[:-1]
RepoName = RepoName[1:]
RepoName = RepoName[:-1]
title = title[1:]
title = title[:-1]
head = head[1:]
head = head[:-1]
base = base[1:]
base = base[:-1]
body = body[1:]
body = body[:-1]
User = User[1:]
User = User[:-1]
token = token[1:]
token = token[:-1]

head = head.encode('utf-8')
base = base.encode('utf-8')
title = title.encode('utf-8')
body = body.encode('utf-8')

body = body.replace('\\n','\n')

payload = {
          "title": title,
          "body": body,
          "head": head,
          "base": base
       }

url='https://api.github.com/repos/%s/%s/pulls?access_token=%s' % (Owner, RepoName,token)
# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
response = requests.post(url, json=payload)