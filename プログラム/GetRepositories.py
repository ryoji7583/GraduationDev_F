#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os, json, functools
from urllib2 import urlopen, Request

# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
def openTrafficAPI (owner, repo, token, path):
    url = "https://api.github.com/repos/%s/%s/%s" % (owner, repo, path)
    headers = {
        'Authorization': 'token %s' % token,
        'Accept': 'application/vnd.github.spiderman-preview'
    }
    return urlopen (Request (url, headers=headers))

# 取ってくるデーター
paths = [
    'pulls/2',
]

def GetDatadict(User,Project):
    connections = []
    # openTrafficAPI関数の部分適用 (認証情報を環境変数から得て)
    fAPI = functools.partial (openTrafficAPI,
                                User,
                                Project,
                                '669ec28450e5d0260dee2266801c8abfa1fff69b')
    # open connections
    connections = [fAPI (p) for p in paths]
    # JSONパース
    for c in connections:
        datadicts = json.loads (c.read ())
    [c.close () for c in connections if c is not None]          # 後始末
    del connections
    return datadicts

#タイトルとコメントを表示
def GetTitle(User,Project):
    datadict1 = GetDatadict(User,Project)
    Title = datadict1["title"]
    return Title

def GetBody(User,Project):
    datadict2 = GetDatadict(User,Project)
    Body = datadict2["body"]
    return Body
