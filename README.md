## Project Setup

1. ``git clone https://github.com/imrancse94/bim-ventures.git`` 
2. ``cp .env.example .env``
3. Configure DB and put DB credential into .env file.
4. Run ``composer update``
5. Run ``php artisan jwt:secret``
6. Run ``php artisan config:cache``
7. Run ``php artisan migrate --seed``

### After successfully setup below credentials will be generated.

#### Admin
email: test@admin.com\
password: 123456

#### Customer
email: solaiman@customer.com\
password: 123456

email: ibrahim@customer.com\
password: 123456

### API Refference

https://documenter.getpostman.com/view/3501446/2s9YXpWKCt