<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDoLists</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type=text/javascript>
        $(document).ready(function() {
            // todoComponent.delete(7);
        });
        let todoComponent = {
            index: async function() {
                let result;
                await axios.get('http://localhost:8080/todo')
                    .then((response) => result = response)
                    .catch((error) => console.log(error.response.data.messages.error))
                return result;
            },
            show: async function(key) {
                await axios.get('http://localhost:8080/todo/' + key)
                    .then((response) => result = response)
                    .catch((error) => console.log(error.response.data.messages.error))
                return result;
            },
            create: async function(data) {
                await axios.post('http://localhost:8080/todo', JSON.stringify(data))
                    .then((response) => result = response)
                    .catch((error) => console.log(error.response.data.messages.error))
            },
            update: async function(key, data) {
                await axios.put('http://localhost:8080/todo/' + key, JSON.stringify(data))
                    .then((response) => result = response)
                    .catch((error) => console.log(error.response.data.messages.error))
            },
            delete: async function(key) {
                await axios.delete('http://localhost:8080/todo/' + key)
                    .then((response) => result = response)
                    .catch((error) => console.log(error.response.data.messages.error))
            },
            send: async function(data) {
                await axios.post('http://localhost:8080/todo/send', JSON.stringify(data))
                    .then((response) => result = response)
                    .catch((error) => console.log(error.response.data.messages.error))
            }
        }

        async function reset() {
            let newTable = document.createElement("tbody");
            newTable.id = "data";
            let oldTable = document.getElementById("data");
            oldTable.parentNode.replaceChild(newTable, oldTable);

            let result = await todoComponent.index();

            let list = result.data.data;
            let tableRow = document.getElementById("data");
            for (let item of list) {
                let row = document.createElement("tr");

                let tilte = document.createElement("td");
                tilte.innerText = item.t_title;

                let key = document.createElement("td");
                key.innerText = item.t_key;

                let content = document.createElement("td");
                content.innerText = item.t_content;

                let cre_t = document.createElement("td");
                cre_t.innerText = item.created_at;

                let upd_t = document.createElement("td");
                upd_t.innerText = item.updated_at;

                let show = document.createElement("td");
                let show_bt = document.createElement("button");
                let show_btAtt = document.createAttribute("onclick");
                show_btAtt.value = "show(this)";
                show_bt.setAttributeNode(show_btAtt);
                show_bt.innerText = "Show";
                show.id = item.t_key;
                show.appendChild(show_bt);

                let byebye = document.createElement("td");
                let bye_bt = document.createElement("button");
                let bye_btAtt = document.createAttribute("onclick");
                bye_btAtt.value = "byebye(this)";
                bye_bt.setAttributeNode(bye_btAtt);
                bye_bt.innerText = "Delete";
                byebye.id = item.t_key;
                byebye.appendChild(bye_bt);

                row.appendChild(tilte);
                row.appendChild(content);
                row.appendChild(cre_t);
                row.appendChild(upd_t);
                row.appendChild(key);
                row.appendChild(show);
                row.appendChild(byebye);
                tableRow.appendChild(row);
            }

            document.getElementById("str").value = "";

            document.getElementById("num").value = "";
            document.getElementById("title_u").value = "";
            document.getElementById("content_u").value = "";

            document.getElementById("title_c").value = "";
            document.getElementById("content_c").value = "";

            let showArea = document.createElement("div");
            showArea.id = "area";
            let oldArea = document.getElementById("area");
            oldArea.parentNode.replaceChild(showArea, oldArea);
        }

        async function show(td) {
            let key = td.parentNode.id;
            let result = await todoComponent.show(key);
            let data = result.data.data;

            let showArea = document.createElement("div");
            showArea.id = "area";
            let oldArea = document.getElementById("area");

            let head = document.createElement("h1");
            head.innerText = "SHOW YOU!!!!!!!!!!!!!!";

            let num = document.createElement("p");
            num.innerText = "ToDo Num: " + data.t_key;
            num.style = "font-size: 36px;"

            let tilte = document.createElement("p");
            tilte.innerText = "ToDo Title: " + data.t_title;
            tilte.style = "font-size: 36px;"

            let content = document.createElement("p");
            content.innerText = "ToDo Content: " + data.t_content;
            content.style = "font-size: 36px;"

            let cre_time = document.createElement("p");
            cre_time.innerText = "Create Time: " + data.created_at;
            cre_time.style = "font-size: 36px;"

            let upd_time = document.createElement("p");
            upd_time.innerText = "Update Time: " + data.updated_at;
            upd_time.style = "font-size: 36px;"

            showArea.appendChild(head);
            showArea.appendChild(num);
            showArea.appendChild(tilte);
            showArea.appendChild(content);
            showArea.appendChild(cre_time);
            showArea.appendChild(upd_time);
            oldArea.parentNode.replaceChild(showArea, oldArea);
        }

        async function create() {
            let title = document.getElementById("title_c").value;
            let content = document.getElementById("content_c").value;

            let str = "{\"title\": " + "\"" + title + "\", \"content\": " + "\"" + content + "\"}";
            let data = JSON.parse(str);
            let result = await todoComponent.create(data);

            let newTable = document.createElement("tbody");
            newTable.id = "data";
            let oldTable = document.getElementById("data");
            oldTable.parentNode.replaceChild(newTable, oldTable);

            reset();
        }

        async function update() {
            let key = document.getElementById("num").value;
            let title = document.getElementById("title_u").value;
            let content = document.getElementById("content_u").value;

            let str = "{\"title\": " + "\"" + title + "\", \"content\": " + "\"" + content + "\"}";
            let data = JSON.parse(str);
            let result = await todoComponent.update(key, data);

            let newTable = document.createElement("tbody");
            newTable.id = "data";
            let oldTable = document.getElementById("data");
            oldTable.parentNode.replaceChild(newTable, oldTable);

            reset();
        }

        async function byebye(td) {
            let key = td.parentNode.id;
            let result = await todoComponent.delete(key);

            let newTable = document.createElement("tbody");
            newTable.id = "data";
            let oldTable = document.getElementById("data");
            oldTable.parentNode.replaceChild(newTable, oldTable);

            reset();
        }

        async function send() {
            let str = document.getElementById("str").value;

            let mail = "{\"str\": " + "\"" + str + "\"}";
            let data = JSON.parse(mail);
            console.log(data);
            let result = await todoComponent.send(data);

            // console.log(result.msg);
            reset();
        }
    </script>
</head>

<body onload="reset()">
    <!-- <button onclick="test()"></button> -->
    <table style="text-align: center">
        <caption>My ToDo List</caption>
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Create Time</th>
                <th>Update Time</th>
                <th>Num</th>
                <th>Show</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody id="data">
        </tbody>
    </table>
    <button onclick="reset()">Reset</button><br><br>
    
    <p>Send the list to the email: <input type="text" id="str" name="str" placeholder="To Email"></p><button onclick="send()">Send</button>

    <h3><br>Create New ToDo Item</h3>
    <p>ToDo Title: <input type="text" id="title_c" name="title" placeholder="title"></p>
    <p>ToDo Content: <input type="text" id="content_c" name="content" placeholder="content"></p>
    <button onclick="create()">Create</button>

    <h3><br>Update ToDo Item</h3>
    <p>ToDo Num: <input type="text" id="num" name="num" placeholder="0"></p>
    <p>ToDo Title: <input type="text" id="title_u" name="title" placeholder="title"></p>
    <p>ToDo Content: <input type="text" id="content_u" name="content" placeholder="content"></p>
    <button onclick="update()">Update</button>

    <br><br>
    <div id="area"></div>
</body>

</html>