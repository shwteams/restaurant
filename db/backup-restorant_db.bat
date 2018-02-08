@echo WELCOME to DO BACKUP TOOL restorant_db
mysqldump -u root -h localhost -p restorant_db --routines > backup_restorant_db.sql
@PAUSE