import {Switch, Route, Redirect} from 'react-router-dom'
import {authRoutes, publicRoutes} from '../routes';
import {SHOP_LIST_ROUTE} from '../utils/consts';
import React from 'react'

function AppRouter() {
  const isAuth = false

  return (
      <>
        {isAuth
          ? (<Switch>
              {authRoutes.map(({path, Component}) => (
                  <Route key={path} path={path} component={Component} exact/>
              ))}
              <Redirect to={SHOP_LIST_ROUTE} />
            </Switch>)
          : (<Switch>
              {publicRoutes.map(({path, Component}) => (
                  <Route key={path} path={path} component={Component} exact/>
              ))}
              <Redirect to={SHOP_LIST_ROUTE} />
            </Switch>)
        }
      </>
  )
}

export {
  AppRouter,
}
