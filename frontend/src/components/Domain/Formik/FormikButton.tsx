import Button, { ButtonProps } from '@/UI/Button'
import { useFormikContext } from 'formik'
import React from 'react'

export type FormikButtonProps = Omit<ButtonProps, 'onClick'> & React.PropsWithChildren

const FormikButton: React.FC<FormikButtonProps> = ({ ...rest }): JSX.Element => {
  const { isSubmitting } = useFormikContext()

  return <Button disabled={isSubmitting} {...rest} type="submit" />
}

export default FormikButton
