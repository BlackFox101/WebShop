import {Switch, Route, Redirect} from 'react-router-dom'
import {authRoutes, publicRoutes} from '../routes';
import {SHOP_LIST_ROUTE} from '../utils/consts';

function AppRouter() {
  const isAuth = false

  return (
      <Switch>
        {isAuth && authRoutes.map(({path, Component}) => (
          <Route key={path} path={path} component={Component} exact/>
        ))}
        {publicRoutes.map(({path, Component}) => (
            <Route key={path} path={path} component={Component} exact/>
        ))}
        <Redirect to={SHOP_LIST_ROUTE} />
      </Switch>
  )
}

export {
  AppRouter,
}