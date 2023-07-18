import Input, { InputProps } from '@/UI/Form/Input'
import { useField } from 'formik'
import React from 'react'

export type FormikInputProps = InputProps & {
  name: string
}

const FormikInput: React.FC<FormikInputProps> = ({ name, ...rest }): JSX.Element => {
  const [field, meta] = useField(name)

  const errorMessage = (meta.touched && meta.error) || undefined

  return <Input errorMessage={errorMessage} {...field} {...rest} />
}

export default FormikInput
