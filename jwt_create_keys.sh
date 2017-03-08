#!/bin/bash

openssl genrsa -out key.priv 2048
openssl rsa -pubout -in jwt.key -out jwt.pub
