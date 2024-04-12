import { initializeApp } from 'firebase/app';
import { getDatabase, ref as dbRef, get,onChildAdded,onChildChanged } from 'firebase/database';

const firebaseConfig = {
  apiKey: "AIzaSyD1Y-RJ0EAfx2WdQvG--fK8e8ThzCcaNP0",
  authDomain: "e-rescue-c063c.firebaseapp.com",
  databaseURL: "https://e-rescue-c063c-default-rtdb.firebaseio.com",
  projectId: "e-rescue-c063c",
  storageBucket: "e-rescue-c063c.appspot.com",
  messagingSenderId: "189191934466",
  appId: "1:189191934466:web:9ed95b052f9ef8a33dcd1b"
};

const firebaseApp = initializeApp(firebaseConfig);
const db = getDatabase(firebaseApp);

export default db
