<h2>.env params</h2>
<ul>
<li>HOST_NAME=localhost:8080</li>
<li>AZURE_STORAGE_NAME=hillel2021</li>
<li>AZURE_STORAGE_KEY=KnArbkUEP16FeoWE6YfInL4ptd6Cy/78jhOKNl57OJKjycE1xSF0fy/KISpfE/ghDD9cxnZiyJfHcwk83vfxXQ==</li>
<li>AZURE_STORAGE_CONTAINER=hillel</li>
<li>AZURE_STORAGE_URL=https://hillel2021.blob.core.windows.net/</li>
<li>AZURE_STORAGE_CONTAINER_PRIVATE=hillelprivate</li>
</ul>
<h2>Also you have to run migration</h2>
<ul>
<li>docker exec -it $(docker ps -aqf "name=app") bash</li>
<li>php artisan migrate:fresh</li>
</ul>



