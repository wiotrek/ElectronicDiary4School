import { Revision } from './revision';

export interface AddNewMarks {
  revision: Revision;
  marks: [
    {
      identifier: string;
      mark: number;
    }
  ];
}
