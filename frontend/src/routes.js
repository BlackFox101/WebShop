import {LOGIN_ROUTE, REGISTRATION_ROUTE, SHOP_LIST_ROUTE, SHOP_ROUTE} from './utils/consts';
import {Login} from './pages/authorization/Login/Login';
import {Registration} from './pages/authorization/Registration/Registration';
import {withContentAreaInCenter} from './components/authorization/withContentAreaInCenter';
import {ShopList} from './pages/ShopList/ShopList';

export const authRoutes = [
  {
    path: '/',
    Component: '',
  }
]

export const publicRoutes = [
  {
    path: LOGIN_ROUTE,
    Component: withContentAreaInCenter(Login),
  },
  {
    path: REGISTRATION_ROUTE,
    Component: withContentAreaInCenter(Registration),
  },
  {
    path: SHOP_LIST_ROUTE,
    Component: ShopList,
  },
  {
    path: SHOP_ROUTE + '/:id',
    Component: 'SHOP,'
  }
]