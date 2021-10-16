import classes from './FormLabel.module.css';

function LabelStar() {
  return (
      <div className={classes.labelStar}>*</div>
  )
}

/**
 * @param {{
 *   isRequired: boolean,
 *   text: string,
 * }} props
 */
function FormLabel({
  isRequired,
  text
}) {
  return (
      <div className={classes.label}>
        <div className={classes.text}>{text}</div>
        {isRequired && <LabelStar />}
      </div>
  )
}

export {
  FormLabel,
}