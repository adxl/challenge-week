FROM ubuntu:latest

RUN apt-get update && apt-get install -y apt-transport-https ca-certificates curl gnupg-agent software-properties-common 

RUN curl -fsSL https://download.docker.com/linux/ubuntu/gpg | apt-key add -
RUN add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"

RUN apt-get update && apt-get install -y docker-ce docker-ce-cli containerd.io
RUN curl -L "https://github.com/docker/compose/releases/download/1.24.1/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
RUN chmod +x /usr/local/bin/docker-compose

WORKDIR /app

COPY ./api ./api
COPY ./docker-compose.yml /app/docker-compose.yml

# RUN sudo usermod -aG docker $USER
# RUN sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

RUN service --status-all
RUN service docker start
# RUN sudo service docker restart

RUN service --status-all

CMD ["docker-compose", "up"]
