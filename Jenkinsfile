pipeline {
    agent {
        label 'wesclic' // Gantilah 'aws-ec2' dengan label agen Jenkins Anda
    }

    stages {
        stage('Checkout') {
            steps {
                // Checkout kode sumber dari repositori git
                git 'https://github.com/RakhaFe21/sip-perbankan.git'
            }
        }
        
        stage('Install Dependencies') {
            steps {
                sh 'composer install' // Instal dependensi Laravel menggunakan Composer
            }
        }
        
        stage('Build') {
            steps {
                // Mengedit file .env
                sh 'sed -i "s/APP_ENV=.*/APP_ENV=local/" .env' // Misalnya, mengubah nilai APP_ENV menjadi "local"
                /* groovylint-disable-next-line LineLength */
                sh 'sed -i "s/DB_HOST=.*/DB_HOST=studiow.cxlxalgmwvj8.ap-southeast-1.rds.amazonaws.com/" .env' // Mengganti host basis data
                sh 'sed -i "s/DB_DATABASE=.*/DB_DATABASE=studiow_sip_perbankan/" .env' // Mengganti nama basis data
                sh 'sed -i "s/DB_USERNAME=.*/DB_USERNAME=admin/" .env' // Mengganti nama pengguna basis data
                sh 'sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=ManajeIDPassword/" .env' // Mengganti kata sandi basis data
            }
        }
        
        stage('Deploy') {
            steps {
                // SSH ke server Anda dan lakukan langkah-langkah deploy yang sesuai
                sh '''
                    cd /var/www/sip-perbankan
                    git pull origin master
                    php artisan migrate
                    php artisan config:cache
                    php artisan route:cache
                    php artisan optimize
                    php artisan serve --host=0.0.0.0
                '''
            }
}

    }
    
    //post {
      //  success {
            // Tambahkan langkah-langkah yang harus dijalankan jika build berhasil
        //}
        //failure {
            // Tambahkan langkah-langkah yang harus dijalankan jika build gagal
        //}
    
}
