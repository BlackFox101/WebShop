import './FormLabel.module.css';

function LabelStar() {
  return (
      <div className={labelStar}>*</div>
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
      <div className={label}>
        <div className={text}>{text}</div>
        {showLabelStar && <LabelStar />}
      </div>
  )
}

export {
  FormLabel,
}
