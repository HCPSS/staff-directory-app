FROM jobber:1.4-alpine3.11

ENV TZ America/New_York

USER root
RUN apk add --no-cache tzdata curl
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone



COPY .jobber /home/jobberuser/.jobber

RUN chown jobberuser:jobberuser /home/jobberuser/.jobber && chmod 0600 /home/jobberuser/.jobber
USER jobberuser