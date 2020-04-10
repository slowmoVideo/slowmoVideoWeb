.PHONY : all
all : thumbs
	cd src && java -jar ../wiki2xhtml.jar slowmo.args

.PHONY : thumbs
thumbs :
	./buildThumbs.sh