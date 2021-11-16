import { useState } from 'react';
import { CardContainer } from '../../../components/authorization/CardContainer/CardContainer';
import { Fragment } from 'react';
import { PrimaryButton } from '../../../components/button/PrimaryButton';
import {
  LabeledField,
  LabeledPasswordField,
} from '../../../components/authorization/LabeledField/LabeledField';
import { NavLink } from 'react-router-dom';
import { LOGIN_ROUTE } from '../../../utils/consts';

const alreadyRegisteredStyles = {
  display: 'flex',
  justifyContent: 'center',
};

function Content() {
  const [password, setPassword] = useState('');
  const [login, setLogin] = useState('');
  const [email, setEmail] = useState('');
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [phone, setPhone] = useState('');

  async function onRegistrationHandler() {
    const response = await fetch('/registration', {
      method: 'POST',
      body: {
        password,
        login,
        email,
        firstName,
        lastName,
        phone,
      },
    });
    console.log(response);
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
      <LabeledField
        text={'Ваше имя'}
        showLabelStar={true}
        onChange={(e) => setFirstName(e.target.value)}
        value={firstName}
      />
      <LabeledField
        text={'Ваша фамилия'}
        showLabelStar={true}
        onChange={(e) => setLastName(e.target.value)}
        value={lastName}
      />
      <LabeledField
        text={'Ваш телефон'}
        showLabelStar={true}
        onChange={(e) => setPhone(e.target.value)}
        value={phone}
      />
      <LabeledPasswordField
        value={password}
        setPassword={(e) => setPassword(e.target.value)}
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
  );
}

function Registration() {
  return (
    <CardContainer title={'Регистрация'}>
      <Content />
    </CardContainer>
  );
}

export { Registration };
