# -*- coding: utf-8 -*-
#!/usr/bin/env python

import urllib
import urllib2
import sys
import requests
import os, json, functools
from GetPRNo import *

# Owner = 'ryoji7583'
# RepoName = 'RepoSampleData'
# title = '変更タイトル'
# state = 'close'
# base = 'master'
# body = '内容を変更した。'
# User = 'ryoji7583'
# token = 'bd307f80537f73e8338ccd585b1aaeafbec9b089'
# PRNo = '156159374'
# number = GetNumber(Owner,RepoName,PRNo)

Owner = sys.argv[1]
RepoName = sys.argv[2]
title = unicode(sys.argv[3], 'cp932')
state = 'close'
base = sys.argv[4]
body = unicode(sys.argv[5], 'cp932')
User = sys.argv[6]
token = sys.argv[7]
PRNo = sys.argv[8]
Owner = Owner[1:]
Owner = Owner[:-1]
RepoName = RepoName[1:]
RepoName = RepoName[:-1]
title = title[1:]
title = title[:-1]
base = base[1:]
base = base[:-1]
body = body[1:]
body = body[:-1]
User = User[1:]
User = User[:-1]
token = token[1:]
token = token[:-1]
PRNo = PRNo[1:]
PRNo = PRNo[:-1]
number = GetNumber(Owner,RepoName,PRNo)

base = base.encode('utf-8')
title = title.encode('utf-8')
body = body.encode('utf-8')

body = body.replace('\\n','\n')

payload = {
  "title": title,
  "body": body,
  "state": state,
  "base": base
}
url='https://api.github.com/repos/%s/%s/pulls/%s' % (Owner, RepoName, number)
# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
response = requests.patch(url,auth=(User, token), json=payload)

