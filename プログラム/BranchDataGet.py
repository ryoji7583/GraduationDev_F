#!/usr/bin/env python
# -*- coding: utf-8 -*-
import os, json, functools
from urllib2 import urlopen, Request

# GitHub Traffic API
# https://developer.github.com/v3/repos/traffic/
def openTrafficAPI (owner, repo, paths):
    url = "https://api.github.com/repos/%s/%s/branches" % (owner, repo)
    return urlopen (Request (url))

# 取ってくるデーター
paths = [
    '',
]

def GetDatadict(User,Project):
    connections = []
    # openTrafficAPI関数の部分適用 (認証情報を環境変数から得て)
    fAPI = functools.partial (openTrafficAPI,
                                User,
                                Project)
    # open connections
    connections = [fAPI (p) for p in paths]
    # JSONパース
    for c in connections:
        datadicts = json.loads (c.read ())
    [c.close () for c in connections if c is not None]          # 後始末
    del connections
    return datadicts

def BranchData(User1, Project1):
    BranchList = GetDatadict(User1,Project1)
    number = len(BranchList) - 1
    while (number >= 0):
        PRdictionary = BranchList[number]
        print PRdictionary[u"name"]
        number = number - 1