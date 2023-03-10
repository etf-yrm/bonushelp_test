<!DOCTYPE html>
<html lang="ru">
	<head>
	<meta charset="UTF-8">
	<style>
		label, input {
			margin-bottom: 5px;
		}
	</style>
	</head>
	<body>
		<h1>For test api</h1>
		<p>
			Simple api provides for the transfer of data by method post, returns a json with the results of the request
		</p>
		<br>
		<hr>
		<br>
		<h2>Add users from CSV</h2>
		<form enctype="multipart/form-data" action="/api" method="POST" >
			<input type="hidden" name="method" value="addUsersFromCsv"/>
			<label for="fileCSV">Выберите файл в формате CSV для загрузки списка пользователей:</label><br>
			<input type="file" id="fileCSV" name="fileCSV" accept="text/csv"/><br>
			<input type="submit" value="Загрузить"/>
		</form>
		<br>
		<hr>
		<br>
		<h2>Create newsletter</h2>
		<form action="/api" method="POST" >
			<input type="hidden" name="method" value="insertNewsletter"/>
			<input type="text" name="name" value="" placeholder="Введите название рассылки..." /><br>
			<input type="text" name="text" value="" placeholder="Введите текст рассылки..." /><br>
			<input type="submit" value="Создать рассылку"/>
		</form>
		<br>
		<hr>
		<br>
		<h2>Start sending newsletter by id</h2>
		<form action="/api" method="POST" >
			<input type="hidden" name="method" value="startNewsletter"/>
			<input type="number" name="startId" value="0"/><br>
			<input type="submit" value="Начать рассылку"/>
		</form>
	</body>
</html>