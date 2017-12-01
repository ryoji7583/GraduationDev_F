#!/usr/bin/env python
# -*- coding: utf-8 -*-

from RepositoryGet import *
from PullRequestGet import *

User = 'ryoji7583'
RepoName = 'Doubutsu'

RepositoryData(User,RepoName)
PullRequestAll(User,RepoName)