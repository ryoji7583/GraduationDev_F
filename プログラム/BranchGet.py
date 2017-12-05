#!/usr/bin/env python
# -*- coding: utf-8 -*-

from BranchDataGet import *
import sys

User = sys.argv[1]
RepoName = sys.argv[2]

BranchData(User,RepoName)