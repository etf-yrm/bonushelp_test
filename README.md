# Solution test task for bonushelp

### Api provides for the transfer of data by method post, returns a json with the results of the request

#### Parameters for connecting to database are specified in the file engine/setting.php

#### For added new users from CSV send to /api {"method": "addUsersFromCsv", "fileCSV": "Файл для теста в CSV.csv"}

#### For insert new newsletter send to /api {"method": "insertNewsletter", "name": "Newsletter name", "text": "Newsletter text"}

#### For start sending newsletter send to /api {"method": "startNewsletter", "startId": "Newsletter ID"}
