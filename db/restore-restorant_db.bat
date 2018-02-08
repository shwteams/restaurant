@color 2
@echo WELCOME to BACKUP TOOL restorant_db
@echo **********************************************

mysql -h localhost -u root -p restorant_db < backup_restorant_db.sql

@pause