import React from 'react';
import {useState} from 'react';
import {CardContainer} from '../../../components/authorization/CardContainer/CardContainer';
import {Fragment} from 'react'
import {PrimaryButton} from '../../../components/button/PrimaryButton';
import {LabeledField, LabeledPasswordField} from '../../../components/authorization/LabeledField/LabeledField';
import {NavLink} from 'react-router-dom';
import {LOGIN_ROUTE} from '../../../utils/consts';

const alreadyRegisteredStyles = {
  display: 'flex',
  justifyContent: 'center',
}

function Content() {
  const [password, setPassword] = useState('')
  const [login, setLogin] = useState('')
  const [email, setEmail] = useState('')

  async function onRegistrationHandler() {
    console.log({
      password,
      login,
      email,
    })
    const response = await fetch('/registration', {
        method: "POST",
        body: {
            password,
            login,
            email,
            firstName: '',
            lastName: '',
            phone: '',
        }
    })
    console.log(response)
  }

  return (
      <Fragment>
        <LabeledField
            text={'Электронная почта'}
            showLabelStar={true}
            onChange={(e) => setEmail(e.target.value)}
            value={email}
        />
        <LabeledField
            text={'Ваш логин'}
            showLabelStar={true}
            onChange={(e) => setLogin(e.target.value)}
            value={login}
        />
        <LabeledPasswordField
            value={password}
            setPassword={setPassword}
        />
        <PrimaryButton
            value={'Зарегестрироваться'}
            onClick={onRegistrationHandler}
        />
        <div style={alreadyRegisteredStyles}>
          <div>Уже зарегестрированы?</div>
          <NavLink to={LOGIN_ROUTE}>Войдите</NavLink>
        </div>
      </Fragment>
  )
}

function Registration() {
  return (
      <CardContainer
        title={'Регистрация'}
      >
        <Content />
      </CardContainer>
  )
}

export {
   Registration,
}
