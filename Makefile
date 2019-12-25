.PHONY: tests cs-fixer phpmd psalm

tests: cs-fixer phpmd psalm

phpmd:
	@./vendor/bin/phpmd src/ text codesize,design

cs-fixer:
	@./vendor/bin/php-cs-fixer fix --verbose --show-progress=estimating --allow-risky=yes

psalm:
	@./vendor/bin/psalm src/
