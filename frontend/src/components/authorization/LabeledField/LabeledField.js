import classes from './LabeledField.module.css';
import {FormLabel} from '../FormLabel/FormLabel';
import {Field} from '../Field/Field';
import {AiOutlineEye, AiOutlineEyeInvisible} from 'react-icons/ai';
import {useState} from 'react';

/**
 * @param {{
 *   text: string,
 *   isRequired: boolean,
 *   onChange: function(Event):void,
 *   value: string,
 * }} props
 */
function LabeledField({
  text,
  isRequired,
  onChange,
  value
}) {
  return (
      <div className={classes.labeledField}>
        <FormLabel text={text} isRequired={isRequired}/>
        <Field onChange={onChange} value={value}/>
      </div>
  )
}

/**
 * @param {{
 *   setPassword: function(string):void,
 *   value: string,
 * }} props
 */
function LabeledPasswordField({
  setPassword,
  value,
}) {
  const [showPassword, setShowPassword] = useState(false)

  function changePasswordVisibility() {
    setShowPassword(!showPassword)
  }

  return (
      <div className={classes.labeledField}>
        <FormLabel text={'Пароль'} isRequired={true}/>
        <div className={classes.passwordField}>
          <Field
              onChange={(e) => setPassword(e.target.value)}
              value={value}
              type={showPassword ? 'text' : 'password'}
              isPassword={true}
          />
          <div className={classes.changePasswordVisibilityWrapper} onClick={changePasswordVisibility}>
            {showPassword ? <AiOutlineEye /> : <AiOutlineEyeInvisible />}
          </div>
        </div>
      </div>
  )
}

export  {
  LabeledField,
  LabeledPasswordField,
}