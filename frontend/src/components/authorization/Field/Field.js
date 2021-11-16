import classes from './Field.module.css';

/**
 * @param {{
 *   onChange: function(Event):void,
 *   value: string,
 *   type: (undefined|string),
 *   isPassword: (undefined|boolean),
 * }} props
 */
function Field({
    onChange,
    value,
    type = 'text',
    isPassword = false,
}) {
  return (
      <input
        className={[classes.field, isPassword ? classes.password : null].join(' ')}
        value={value}
        onChange={onChange}
        type={type}
      />
  )
}

export {
  Field,
}