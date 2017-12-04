#!/usr/bin/env python
# -*- coding: utf-8 -*-

from RepositoryGet import *
from PullRequestGet import *
import sys

User = sys.argv[1]
RepoName = sys.argv[2]
# User = 'ryoji7583'
# RepoName = 'Doubutsu'

# print User
# print RepoName

RepositoryData(User,RepoName)
PullRequestAll(User,RepoName)