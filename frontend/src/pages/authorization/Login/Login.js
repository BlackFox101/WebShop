import {CardContainer} from '../../../components/authorization/CardContainer/CardContainer';
import {Fragment, useState} from 'react';
import {LabeledField, LabeledPasswordField} from '../../../components/authorization/LabeledField/LabeledField';
import {PrimaryButton} from '../../../components/button/PrimaryButton';
import {NavLink, useHistory} from 'react-router-dom';
import {REGISTRATION_ROUTE, SHOP_LIST_ROUTE} from '../../../utils/consts';

const notRegisteredStyles = {
  display: 'flex',
  justifyContent: 'center',
}

function Content() {
  const [loginOrEmail, setLoginOrEmail] = useState('')
  const [password, setPassword] = useState('')
  const history = useHistory()

  function onLoginHandler() {
    console.log({
      loginOrEmail,
      password,
    })
    history.push(SHOP_LIST_ROUTE)
  }

  return (
      <Fragment>
         <LabeledField
            text={'Логин или e-mail'}
            onChange={(e) => setLoginOrEmail(e.target.value)}
            value={loginOrEmail}
         />
        <LabeledPasswordField
            setPassword={(e) => setPassword(e.target.value)}
            value={password}
        />
        <PrimaryButton
            value={'Войти'}
            onClick={onLoginHandler}
        />
        <div style={notRegisteredStyles}>
          <div>Еще нет аккаунта?</div>
          <NavLink to={REGISTRATION_ROUTE}>Войдите</NavLink>
        </div>
      </Fragment>
  )
}

function Login() {
  return (
      <CardContainer title={'Войти'}>
        <Content />
      </CardContainer>
  )
}

export {
  Login,
}