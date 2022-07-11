const mysql = require('mysql');
const MySQLEvents = require('@rodrigogs/mysql-events');
const axios = require('axios');

const sourceConfig = {
    host: 'legacy_database',
    user: 'root',
    password: 'legacy_root_pwd'
  };

  const destinationConfig = {
    baseURL: 'http://greenfield-app',
    timeout: 1000,
    headers: { 'Content-Type': 'application/json' }
  }

const program = async () => {
    const connection = mysql.createConnection(sourceConfig);

    const destination = axios.create(destinationConfig);
  
    const instance = new MySQLEvents(connection, {
      startAtEnd: true
    });
  
    await instance.start();
  
    instance.addTrigger({
      name: 'monitoring all statments',
      expression: 'legacy_db.*', // listen to TEST database !!!
      statement: MySQLEvents.STATEMENTS.ALL, // you can choose only insert for example MySQLEvents.STATEMENTS.INSERT, but here we are choosing everything
      onEvent: e => {
        console.log(e);
        destination.post('/api/collector',e).then(function(response){
            console.log(response.status+" Consumed")
        })
      }
    });
  
    instance.on(MySQLEvents.EVENTS.CONNECTION_ERROR, console.error);
    instance.on(MySQLEvents.EVENTS.ZONGJI_ERROR, console.error);
  };
  
  program()
    .then(()=>{
        console.log("Started")
    })
    .catch(console.error);