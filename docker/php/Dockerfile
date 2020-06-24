FROM ${PHP_IMAGE:-quay.io/api-platform/php}

RUN apk update

# Install base and dev packages
RUN apk add --no-cache --virtual build-dependencies build-base

RUN apk -Uuv add --no-cache \
  make \
  curl \
  groff \
  less \
  nodejs-npm \
  bash \
  python2 \
  ruby

RUN  apk --no-cache add ca-certificates wget bash \
	&& wget -q -O /etc/apk/keys/sgerrand.rsa.pub https://alpine-pkgs.sgerrand.com/sgerrand.rsa.pub \
	&& wget https://github.com/sgerrand/alpine-pkg-glibc/releases/download/2.29-r0/glibc-2.29-r0.apk \
	&& apk add glibc-2.29-r0.apk
