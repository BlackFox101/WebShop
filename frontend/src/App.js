import './App.css';
import {useState, useEffect} from 'react';
import {Registration} from './pages/authorization/Registration/Registration';
import {Login} from './pages/authorization/Login/Login';
import {withContentAreaInCenter} from './hoc/withContentAreaInCenter';

function App() {
  const [posts, setPosts] = useState([])

  return (
    <div className="App">
      {withContentAreaInCenter(Registration)()}
      {/*<Login />*/}
    </div>
  );
}

export default App;
