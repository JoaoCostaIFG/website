FROM matrixdotorg/synapse:latest

RUN apt-get update && \
        apt-get install -y git && \
        apt-get clean && \
        rm -rf /var/lib/apt/lists/* && \
        pip install "git+https://github.com/matrix-org/synapse-s3-storage-provider.git"
