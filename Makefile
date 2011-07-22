.PHONY : all
all : thumbs
	java -jar wiki2xhtml.jar slowmo.args

.PHONY : thumbs
thumbs :
	./buildThumbs.sh