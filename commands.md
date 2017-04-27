#Database
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create

#Schema
php bin/console doctrine:schema:validate
php bin/console doctrine:schema:update --force

# Cache
php bin/console cache:clear
php bin/console cache:clear --no-debug
php bin/console cache:clear --env=prod

# Router
php bin/console debug:router

# Bundle
php bin/console generate:bundle

#Entity
php bin/console doctrine:generate:entity

php bin/console doctrine:generate:entities ApiBundle:SmartPackageConfiguration
php bin/console doctrine:generate:entities ApiBundle:Medication

# Form
php bin/console generate:doctrine:form ApiBundle:SmartPackageConfiguration
php bin/console generate:doctrine:form ApiBundle:Medication
