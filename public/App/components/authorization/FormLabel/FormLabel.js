import classes from './FormLabel.module.css';

function LabelStar() {
  return (
      <div className={classes.labelStar}>*</div>
  )
}

/**
 * @param {{
 *   showLabelStar: boolean,
 *   text: string,
 * }} props
 */
function FormLabel({
  showLabelStar,
  text
}) {
  return (
      <div className={classes.label}>
        <div className={classes.text}>{text}</div>
        {showLabelStar && <LabelStar />}
      </div>
  )
}

export {
  FormLabel,
}