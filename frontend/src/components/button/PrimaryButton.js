import classes from './PrimaryButton.module.css';
import React from 'react'

/**
 * @param {{
 *   onClick: function(Event):void,
 *   value: string,
 * }} props
 */
function PrimaryButton({
  onClick,
  value,
}) {
  return (
      <button
          className={classes.button}
          onClick={onClick}
      >{value}</button>
  )
}

export {
  PrimaryButton,
}
