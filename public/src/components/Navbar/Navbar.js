import './Navbar.module.css';
import {AiOutlineUser, AiOutlineShoppingCart} from 'react-icons/ai'
import {MdOutlineFavoriteBorder} from 'react-icons/md'
import {CgProfile} from 'react-icons/cg'
import {BiExit} from 'react-icons/bi'
import {NavLink} from 'react-router-dom';
import {LOGIN_ROUTE, SHOP_LIST_ROUTE} from '../../utils/consts';
import {SearchField} from './SearchField/SearchField';

function NotAuthNavbar() {
  return (
      <div className={navbar}>
        <div className={navbarContent}>
          <div style={{display: 'flex'}}>
            <NavLink className={logo} to={SHOP_LIST_ROUTE}>
              <img src={'https://dejpknyizje2n.cloudfront.net/svgcustom/clipart/preview/wolf-coyote-dog-10066-11456-550x550.png'} />
            </NavLink>
            <SearchField />
          </div>
          <NavLink to={LOGIN_ROUTE} className={loginButton}>
            <AiOutlineUser />
            <div>Войти</div>
          </NavLink>
        </div>
      </div>
  )
}

/**
 * @param {{
 *   Icon: React.Component,
 *   url: string,
 * }}
 */
function AuthIcon({
  Icon,
  url,
}) {
  return (
      <NavLink className={authIcon} to={{url}}>
        <Icon />
      </NavLink>
  )
}

function AuthNavbar() {
  return (
      <div className={navbar}>
        <div className={navbarContent}>
          <div style={{display: 'flex'}}>
            <NavLink className={logo} to={SHOP_LIST_ROUTE}>
              <img src={'https://dejpknyizje2n.cloudfront.net/svgcustom/clipart/preview/wolf-coyote-dog-10066-11456-550x550.png'} />
            </NavLink>
            <SearchField />
          </div>
          <div>
              <AuthIcon Icon={CgProfile} url={'/'} />
              <AuthIcon Icon={MdOutlineFavoriteBorder} url={'/'} />
              <AuthIcon Icon={BiExit} url={'/'} />
          </div>
        </div>
      </div>
  )
}

export {
  NotAuthNavbar,
  AuthNavbar,
}