import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import {BrowserRouter} from 'react-router-dom';
import {AppRouter} from './components/AppRouter';
import {AuthNavbar, NotAuthNavbar} from './components/Navbar/Navbar';

const isAuth = true

ReactDOM.render(
  <BrowserRouter>
    {isAuth
      ? <AuthNavbar />
      : <NotAuthNavbar />
    }
    <AppRouter />
  </BrowserRouter>,
  document.getElementById('root')
);

/*
import ReactDOM from "react-dom";
import React from "react";

ReactDOM.render(
    <div>Hello world!</div>,
    document.getElementById('root')
);*/
