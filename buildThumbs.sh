#!/bin/bash

if [ ! -e thumbs ]
then
    mkdir thumbs
fi

for i in pngGUI/*
do
    echo $i
    out="thumbs/thumb_$(basename $i)"
    convert -resize 300x300 $i ${out}
done