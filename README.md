# testproject-symfony

#####Для того, чтобы запустить проект, нужно: 

#####Поднять docker-контейнеры  
docker-compose up --build

#####Зайти в php-контейнер testproject-php-fpm, выполнить:  
composer install  
bin/console doctrine:migrations:migrate  
bin/console doctrine:fixtures:load  
  
#####API будет доступно по ссылкам  
curl -X GET http://localhost:8080/api/book/search?q=Книга  
curl -H 'Content-Type: application/json' --data '{"name": "Автор 1"}' http://localhost:8080/api/author/create  
curl -H 'Content-Type: application/json' --data '{"name": "Книга 1", "translations": [{"locale": "en", "name": "Book 1"}],"authors": [1]}' http://localhost:8080/api/book/create  
curl -X GET http://localhost:8080/api/en/book/1  