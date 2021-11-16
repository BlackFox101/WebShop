import {AuthNavbar, NotAuthNavbar} from '../components/Navbar/Navbar';

const isAuth = false

function withNavbar(WrappedComponent) {
  return () => (
      <div>
        {isAuth
          ? <AuthNavbar />
          : <NotAuthNavbar />
        }
        <WrappedComponent />
      </div>
  )
}

export {
  withNavbar,
}