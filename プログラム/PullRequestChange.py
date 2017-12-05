# -*- coding: utf-8 -*-
#!/usr/bin/env python

import urllib
import urllib2
import sys
import requests
import os, json, functools

Owner = 'ryoji7583'
RepoName = 'RepoSampleData'
title = '変更後のタイトル'
state = 'close'
base = 'master'
body = '変更後のボディ部分'
User = 'ryoji7583'
token = 'ccda23d9762b026096db58e5ba459c8a8ebba745'
number = '2'
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
print response.json()

