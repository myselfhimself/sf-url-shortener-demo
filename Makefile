tests-docker:
	bin/kconsole doctrine:database:drop --force --env=test || true
	bin/kconsole doctrine:database:create --env=test
	bin/kconsole doctrine:schema:create -n --env=test
	bin/kphpunit

