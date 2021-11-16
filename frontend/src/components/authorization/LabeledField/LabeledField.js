import classes from './LabeledField.module.css';
import {FormLabel} from '../FormLabel/FormLabel';
import {Field} from '../Field/Field';
import {AiOutlineEye, AiOutlineEyeInvisible} from 'react-icons/ai';
import {useState} from 'react';
import React from 'react'

/**
 * @param {{
 *   text: string,
 *   showLabelStar: (undefined|boolean),
 *   onChange: function(Event):void,
 *   value: string,
 * }} props
 */
function LabeledField({
  text,
  showLabelStar = false,
  onChange,
  value
}) {
  return (
      <div className={classes.labeledField}>
        <FormLabel text={text} showLabelStar={showLabelStar}/>
        <Field onChange={onChange} value={value}/>
      </div>
  )
}

/**
 * @param {{
 *   setPassword: function(Event):void,
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
        <FormLabel text={'Пароль'} showLabelStar={true}/>
        <div className={classes.passwordField}>
          <Field
              onChange={setPassword}
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
