import './PrimaryButton.module.css';

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
          className={button}
          onClick={onClick}
      >{value}</button>
  )
}

export {
  PrimaryButton,
}
